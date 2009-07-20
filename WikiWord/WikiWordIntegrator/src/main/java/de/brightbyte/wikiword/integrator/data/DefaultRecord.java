package de.brightbyte.wikiword.integrator.data;

import java.io.Serializable;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.Collection;
import java.util.HashMap;
import java.util.Map;

public class DefaultRecord implements Record, Serializable, Cloneable {

	private static final long serialVersionUID = 5538610907302985392L;
	
	protected Map<String, Object> data;
	
	public DefaultRecord() {
		this(null);
	}
	
	protected DefaultRecord(Map<String, Object> data) {
		if (data==null) data = new HashMap<String, Object>();
		this.data = data;
	}
	
	public Object get(String key) {
		return data.get(key);
	}

	public Iterable<String> keys() {
		return data.keySet();
	}

	public Object set(String key, Object value) {
		return data.put(key, value);
	}

	public boolean add(String key, Object value) {
		Object old = data.get(key);
		
		if (value instanceof Object[]) {
			value = Arrays.asList((Object[])value);
		}
		
		if (value instanceof Collection && ((Collection)value).isEmpty()) {
			return false;
		}
		
		if (old==null) {
			data.put(key, value);
		}
		else if (old instanceof Collection) {
			if (value instanceof Collection) ((Collection<Object>)old).addAll((Collection<Object>)value);
			else ((Collection<Object>)old).add(value);
		}
		else {
			Collection<Object> r = new ArrayList<Object>();
			r.add(old);

			if (value instanceof Collection) r.addAll((Collection<Object>)value);
			else r.add(value);

			data.put(key, r);
		}
		
		return true;
	}

	public int addAll(Record r) {
		int c = 0;
		
		for (String k: r.keys()) {
			if (add(k, r.get(k))) c++;
		}
		
		return c;
	}
	
	@Override
	public String toString() {
		return data.toString();
	}

	@Override
	public int hashCode() {
		return data.hashCode();
	}

	@Override
	public boolean equals(Object obj) {
		if (this == obj)
			return true;
		if (obj == null)
			return false;
		if (getClass() != obj.getClass())
			return false;

		final DefaultRecord other = (DefaultRecord) obj;
		if (!data.equals(other.data))
			return false;
		return true;
	}

	public Object getPrimitive(String key) {
		Object v = get(key);
		if (v==null) return null;
		if (v instanceof Collection) v = ((Collection<Object>)v).iterator().next();
		return v;
	}

	public boolean isMultiValue(String key) {
		Object v = get(key);
		if (v!=null && v instanceof Collection) return true;
		return false;
	}
	
	public DefaultRecord clone() {
		try {
			DefaultRecord r = (DefaultRecord)super.clone();
			r.data = new HashMap<String, Object>(data.size());
			r.data.putAll(data);
			return r;
		} catch (CloneNotSupportedException e) {
			throw new Error("CloneNotSupported in clonable object");
		}
	}
	
}
