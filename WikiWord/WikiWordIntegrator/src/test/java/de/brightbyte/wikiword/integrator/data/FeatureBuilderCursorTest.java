package de.brightbyte.wikiword.integrator.data;

import java.util.ArrayList;
import java.util.Collection;

import junit.framework.TestCase;
import de.brightbyte.data.cursor.DataCursor;
import de.brightbyte.data.cursor.IteratorCursor;
import de.brightbyte.util.PersistenceException;

public class FeatureBuilderCursorTest extends TestCase {

	private static <T> Collection<T> slurp(DataCursor<T> cursor) throws PersistenceException {
		ArrayList<T> list = new ArrayList<T>();
		T obj;
		while ((obj = cursor.next()) != null) list.add(obj);
		return list;
	}
	
	public void testNext() throws PersistenceException {
		DefaultRecord a = new DefaultRecord();
		a.add("authority", "ACME");
		a.add("id", 1);
		a.add("foo", "A");

		DefaultRecord b = new DefaultRecord();
		b.add("authority", "ACME");
		b.add("id", 1);
		b.add("foo", "B");
		
		DefaultRecord x = new DefaultRecord();
		x.add("authority", "ACME");
		x.add("id", 2);
		x.add("foo", "X");

		DefaultRecord y = new DefaultRecord();
		y.add("authority", "ACME");
		y.add("id", 2);
		y.add("foo", "Y");
		
		DefaultRecord p = new DefaultRecord();
		p.add("authority", "ACME");
		p.add("id", 3);
		p.add("foo", "P");

		DefaultRecord q = new DefaultRecord();
		q.add("authority", "ACME");
		q.add("id", 3);
		q.add("foo", "Q");
		
		//--------------------------------------
		FeatureSet ab = new DefaultFeatureSet();
		ab.addFeature("authority", "ACME", null);
		ab.addFeature("id", 1, null);
		ab.addFeature("id", 1, null);
		ab.addFeature("FOO", "A", null);
		ab.addFeature("FOO", "B", null);
		
		FeatureSet xy = new DefaultFeatureSet();
		xy.addFeature("authority", "ACME", null);
		xy.addFeature("id", 2, null);
		xy.addFeature("id", 2, null);
		xy.addFeature("FOO", "X", null);
		xy.addFeature("FOO", "Y", null);
		
		FeatureSet pq = new DefaultFeatureSet();
		pq.addFeature("authority", "ACME", null);
		pq.addFeature("id", 3, null);
		pq.addFeature("id", 3, null);
		pq.addFeature("FOO", "P", null);
		pq.addFeature("FOO", "Q", null);
		
		//--------------------------------------
		ArrayList<Record> source = new ArrayList<Record>();
		source.add(a);
		source.add(b);
		source.add(x);
		source.add(y);
		source.add(p);
		source.add(q);
		
		ArrayList<FeatureSet> exp = new ArrayList<FeatureSet>();
		exp.add(ab);
		exp.add(xy);
		exp.add(pq);
		
		PropertyMappingFeatureBuilder<Record> mapping = new PropertyMappingFeatureBuilder<Record>("authority", "id");
		mapping.addMapping("authority", new Record.Accessor<String>("authority", String.class), null); 
		mapping.addMapping("id", new Record.Accessor<Integer>("id", Integer.class), null); 
		mapping.addMapping("FOO", new Record.Accessor<String>("foo", String.class), null); //TODO: califiers 

		DataCursor<Record> sourceCursor = new IteratorCursor<Record>(source.iterator());
		DataCursor<FeatureSet> cursor = new FeatureBuilderCursor<Record>(sourceCursor, mapping);
		
		Collection<FeatureSet> act = slurp(cursor);
		assertEquals(exp, act);
	}

}
